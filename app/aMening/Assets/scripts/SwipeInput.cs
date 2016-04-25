using UnityEngine;
using System.Collections;

public class SwipeInput : MonoBehaviour
{

    // Use this for initialization
    void Start()
    {
        
    }
    public float tweenMultipier;
    float split = 0.5f;
    public Material splitMaterial;
    public float snapSplit = 0.15f;
    public float confirmSplit = 0.005f;
    public float Split
    {
        get { return split; }
        set
        {
            split = Mathf.Clamp(value,0,1);
            if (splitMaterial)
            {
                splitMaterial.SetFloat("_Split", split);
            }
        }
    }
    void Update()
    {

        if (Input.touchCount > 0)
        {
            Split += Input.touches[0].deltaPosition.x / Screen.width;
            Debug.Log(Split);
        }
        else
        { 
            float delta = Mathf.Abs(Split - 0.5f) ;
            if (delta < 0.5f - snapSplit)
            {
                delta *= tweenMultipier;
                if (Split > 0.5f)
                {
                    Split -= delta;
                }
                else
                {
                    Split += delta;
                }
            }
            else if (delta < 0.5f - confirmSplit)
            {

                delta *= 0.5f - tweenMultipier;
                if (Split > 0.5f)
                {
                    Split += delta;
                }
                else
                {
                    Split -= delta;
                }
            }
            else
            {
                Split = Mathf.Round(Split);
                // confirm
            }
        }
    }
}
