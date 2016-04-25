using UnityEngine;
using System.Collections;
using UnityEngine.UI;

public class SwipeInput : MonoBehaviour
{
    public float tweenMultipier;
    float split = 0.5f;
    public Material splitMaterial;
    public LayoutElement left;
    public LayoutElement right;
    public Text leftText;
    public Text rightText;
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
            left.flexibleWidth = split * 1000;
            right.flexibleWidth = (1 - split) * 1000;
            Color c = leftText.color;
            c.a = split * 2;
            leftText.color = c;
            c = rightText.color;
            c.a = (1 - split)*2;
            rightText.color = c;
        }
    }
    void Start()
    {
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
